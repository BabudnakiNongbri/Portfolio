
$(function () {
    const API = "https://openlibrary.org/search.json";
    const STORAGE = "bookExplorerFavorites";
    const PAGE_SIZE = 12;

    const subjects = {
        "All": "subject:fiction",
        "Art & Design": "subject:art",
        "Architecture": "subject:architecture",
        "Travel": "subject:travel",
        "Children": "subject:children",
        "Fiction": "subject:fiction",
        "Technology": "subject:technology",
        "Science": "subject:science"
    };

    let books = [];
    let page = 1;
    let category = "All";
    let query = "";
    let onlyFavorites = false;
    let maxYear = 2026;
    let requestNumber = 0;
    let loading = false;
    let hasMore = true;

    let favorites = [];
    try {
        favorites = JSON.parse(localStorage.getItem(STORAGE) || "[]");
        if (!Array.isArray(favorites)) favorites = [];
    } catch (e) {
        favorites = [];
    }

    function saveFavorites() {
        localStorage.setItem(STORAGE, JSON.stringify(favorites));
        $("#favCount").text(favorites.length);
    }

    function coverURL(book) {
        if (book.cover_i) {
            return "https://covers.openlibrary.org/b/id/" +
                book.cover_i + "-M.jpg";
        }

        if (book.cover_edition_key) {
            return "https://covers.openlibrary.org/b/olid/" +
                book.cover_edition_key + "-M.jpg";
        }

        return "";
    }

    function makeBook(book) {
        return {
            id: book.key,
            title: book.title || "Untitled",
            authors: book.author_name || ["Unknown author"],
            year: book.first_publish_year || null,
            cover: coverURL(book),
            subjects: book.subject || [],
            edition: book.edition_count || 0
        };
    }

    function loadBooks(reset = true) {
        if (loading) return;

        if (reset) {
            page = 1;
            books = [];
            hasMore = true;
        }

        if (!hasMore) return;

        loading = true;
        const request = ++requestNumber;
        const term = $("#searchInput").val().trim();

        $("#message").text("Discovering books...");
        $("#loadMore").prop("hidden", true);

        let searchQuery;

        if (term) {
            searchQuery = term;
        } else {
            searchQuery = subjects[category] || subjects.All;
        }

        $.ajax({
            url: API,
            method: "GET",
            dataType: "json",
            timeout: 15000,
            data: {
                q: searchQuery,
                page: page,
                limit: 40,
                fields: "key,title,author_name,cover_i,cover_edition_key,first_publish_year,subject,edition_count"
            }
        })
        .done(function (data) {
            if (request !== requestNumber) return;

            const results = (data.docs || []).map(makeBook);

            // Prefer actual covers rather than filling the grid
            // with placeholder images.
            const covered = results.filter(book => book.cover);

            books = reset ? covered : books.concat(covered);
            hasMore = page * 40 < (data.numFound || 0);

            renderBooks();

            if (!books.length) {
                $("#message").text(
                    "No books with covers were found. Try another search."
                );
            }
        })
        .fail(function () {
            if (request !== requestNumber) return;

            $("#message").text(
                "Could not load books. Check your connection and try again."
            );
        })
        .always(function () {
            if (request !== requestNumber) return;

            loading = false;

            $("#loadMore").prop(
                "hidden",
                !hasMore || !books.length
            );
        });
    }

    function renderBooks() {
        let result = books.slice();

        if (category !== "All" && $("#searchInput").val().trim()) {
            const term = category.toLowerCase();

            result = result.filter(book =>
                book.subjects.some(subject =>
                    subject.toLowerCase().includes(term.split(" ")[0])
                )
            );
        }

        result = result.filter(book =>
            !book.year || book.year <= maxYear
        );

        if (onlyFavorites) {
            result = result.filter(book =>
                favorites.includes(book.id)
            );
        }

        const sort = $("#sortSelect").val();

        if (sort === "title") {
            result.sort((a, b) => a.title.localeCompare(b.title));
        }

        if (sort === "year") {
            result.sort((a, b) => (b.year || 0) - (a.year || 0));
        }

        $("#sectionTitle").text(
            onlyFavorites ? "Your Favorites" :
            $("#searchInput").val().trim() || category === "All"
                ? "Discover Books" : category
        );

        $("#resultCount").text(
            result.length + " books available"
        );

        $("#bookGrid").empty();

        if (!result.length) {
            $("#message").text(
                onlyFavorites
                    ? "You haven't saved any matching favorites yet."
                    : "No matching books. Try another search or filter."
            );
            return;
        }

        $("#message").text("");

        result.forEach(function (book) {
            const card = $("<article>")
                .addClass("book-card")
                .attr("tabindex", "0")
                .attr("role", "button")
                .attr("aria-label", "View " + book.title)
                .on("click keydown", function (event) {
                    if (event.type === "click" ||
                        event.key === "Enter") {
                        if (event.type === "keydown") {
                            event.preventDefault();
                        }
                        showDetails(book);
                    }
                });

            const wrap = $("<div>").addClass("cover-wrap");

            const img = $("<img>")
                .addClass("cover")
                .attr("src", book.cover)
                .attr("alt", book.title + " book cover");

            img.on("error", function () {
                $(this).closest(".book-card").remove();
            });

            const saved = favorites.includes(book.id);

            const heart = $("<button>")
                .addClass("fav-button")
                .toggleClass("saved", saved)
                .attr("title", saved ? "Remove favorite" : "Save favorite")
                .attr("aria-label", saved ? "Remove favorite" : "Save favorite")
                .text(saved ? "♥" : "♡")
                .on("click", function (event) {
                    event.stopPropagation();

                    if (favorites.includes(book.id)) {
                        favorites = favorites.filter(id => id !== book.id);
                    } else {
                        favorites.push(book.id);
                    }

                    saveFavorites();
                    renderBooks();
                });

            wrap.append(img, heart);

            card.append(
                wrap,
                $("<h3>").addClass("book-title").text(book.title),
                $("<p>").addClass("book-author")
                    .text(book.authors.join(", ")),
                $("<p>").addClass("book-year")
                    .text(book.year || "Publication year unavailable"),
                $("<p>").addClass("book-action").text("View details ↗")
            );

            $("#bookGrid").append(card);
        });
    }

    function showDetails(book) {
        $("#bookModal").remove();

        const modal = $("<div>")
            .attr("id", "bookModal")
            .addClass("modal-overlay");

        const panel = $("<div>")
            .addClass("modal-panel")
            .attr("role", "dialog")
            .attr("aria-modal", "true");

        const close = $("<button>")
            .addClass("modal-close")
            .text("×")
            .attr("aria-label", "Close details")
            .on("click", () => modal.remove());

        const image = $("<img>")
            .addClass("modal-cover")
            .attr("src", book.cover)
            .attr("alt", book.title);

        const info = $("<div>").addClass("modal-info");

        info.append(
            $("<p>").addClass("eyebrow").text("BOOK DETAILS"),
            $("<h2>").text(book.title),
            $("<p>").text("By " + book.authors.join(", ")),
            $("<p>").text(
                "First published: " + (book.year || "Not available")
            ),
            $("<p>").text(
                "Known editions: " + (book.edition || "Not available")
            )
        );

        if (book.subjects.length) {
            info.append(
                $("<p>").addClass("modal-subjects")
                    .text("Subjects: " + book.subjects.slice(0, 6).join(", "))
            );
        }

        info.append(
            $("<a>")
                .addClass("detail-link")
                .attr("href", "https://openlibrary.org" + book.id)
                .attr("target", "_blank")
                .attr("rel", "noopener noreferrer")
                .text("Explore on Open Library ↗")
        );

        panel.append(close, image, info);
        modal.append(panel);

        modal.on("click", function (e) {
            if (e.target === modal[0]) modal.remove();
        });

        $(document).on("keydown.bookModal", function (e) {
            if (e.key === "Escape") {
                modal.remove();
                $(document).off("keydown.bookModal");
            }
        });

        $("body").append(modal);
    }

    function selectCategory(value) {
        category = value;
        onlyFavorites = false;

        $("#favoritesOnly").prop("checked", false);
        $(".category, .nav-link").removeClass("active");

        $(".category, .nav-link").filter(function () {
            return $(this).data("category") === value;
        }).addClass("active");

        loadBooks();
    }

    $("#searchForm").on("submit", function (e) {
        e.preventDefault();
        category = "All";
        $(".category, .nav-link").removeClass("active");
        $('.category[data-category="All"], .nav-link[data-category="All"]')
            .addClass("active");
        loadBooks();
    });

    $(".category, .nav-link").on("click", function (e) {
        e.preventDefault();
        selectCategory($(this).data("category"));
    });

    $("#sortSelect").on("change", renderBooks);

    $("#yearRange").on("input change", function () {
        maxYear = Number(this.value);
        $("#yearValue").text(maxYear);
        renderBooks();
    });

    $("#favoritesOnly").on("change", function () {
        onlyFavorites = this.checked;
        renderBooks();
    });

    $("#favoritesBtn").on("click", function () {
        onlyFavorites = !onlyFavorites;
        $("#favoritesOnly").prop("checked", onlyFavorites);
        renderBooks();
    });

    $("#clearFilters").on("click", function () {
        $("#searchInput").val("");
        $("#yearRange").val(2026);
        $("#yearValue").text(2026);
        $("#sortSelect").val("relevance");
        $("#favoritesOnly").prop("checked", false);

        maxYear = 2026;
        onlyFavorites = false;
        category = "All";

        $(".category, .nav-link").removeClass("active");
        $('.category[data-category="All"], .nav-link[data-category="All"]')
            .addClass("active");

        loadBooks();
    });

    $("#loadMore").on("click", function () {
        if (loading || !hasMore) return;
        page++;
        loadBooks(false);
    });

    saveFavorites();
    loadBooks();
});
