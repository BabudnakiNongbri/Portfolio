# Hosting guide

Vercel and GitHub Pages only serve static files, so they cannot run PHP or MySQL.
The portfolio is therefore split in two:

| Part | Hosted on | Cost |
|---|---|---|
| Portfolio + static projects (football store, quiz, calculator, weather, book explorer, ajax) | **Vercel** | free |
| PHP projects (employee, contact, nexora, department) | **Render** (Docker) | free |
| MySQL database | **Aiven** | free |

## 1. Create the free MySQL database (Aiven)
1. Sign up at https://aiven.io -> Create service -> **MySQL** -> choose the **Free** plan -> Create.
2. When it is "Running", open the service and copy: **Host, Port, User (avnadmin), Password**.
3. You do NOT need to create tables - the PHP code creates the databases and tables on first visit.

## 2. Push the code to GitHub
Copy these files over your existing Portfolio folder (keeps your git history), then:
```
git rm -r --cached images/quiz-portal_files
git add -A
git commit -m "Make PHP projects deployable online"
git push
```

## 3. Deploy the PHP projects on Render
1. https://render.com -> sign in with GitHub -> **New +** -> **Blueprint** -> pick your Portfolio repo
   (or New -> Web Service -> Runtime: **Docker**, Instance type: **Free**).
2. Fill in the environment variables:
   - `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASSWORD` -> from Aiven
   - `NEXORA_ADMIN_PASSWORD` -> password for the Nexora admin (email: admin@mca42.com)
   - `CONTACT_ADMIN_PASSWORD` -> password for the Contact Manager admin (email: admin@contactly.com)
3. Deploy. You get a URL like `https://portfolio-php.onrender.com`.
   Test: `/employee-management/`, `/contact-management/`, `/nexora-company/`, `/department-portal/`.

## 4. Deploy the portfolio on Vercel
1. Open `js/projects.js` and set `PHP_HOST` to your Render URL (no trailing slash). Commit + push.
2. https://vercel.com -> **Add New -> Project** -> import the repo.
   Framework Preset: **Other**. Leave build/output settings empty. Deploy.
3. `.vercelignore` keeps the PHP folders out of Vercel (so PHP source is never downloadable).

## Notes
- Render's free server sleeps after 15 min idle; the first PHP page can take ~1 min. The portfolio pings it on load to wake it early.
- Render's disk is temporary, which is why data lives in Aiven, not SQLite.
- Local XAMPP still works unchanged: with no `DB_HOST` set, the code uses localhost/root.
- Run locally with Docker (optional): `docker build -t php-projects . && docker run -p 10000:10000 -e DB_HOST=... php-projects`
