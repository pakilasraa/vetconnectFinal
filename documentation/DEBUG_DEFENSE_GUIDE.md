# VetConnect V2 Debug and Defense Guide

Purpose:
- Help the team respond during live debugging
- Prepare answers for likely panel questions
- Give a quick recovery plan if errors appear in demo

## 1. 60-Second Debug Flow (During Checking)

When an error appears, follow this script:
1. Identify where it fails (login, booking, records, assets, DB).
2. Reproduce once quickly.
3. Check browser error message and Laravel log.
4. Apply the smallest safe fix.
5. Re-test same action.
6. Continue demo and explain root cause briefly.

Speaker line:
"We identified the issue in [module], applied a targeted fix, and verified the workflow is working again."

## 2. Quick Command Cheatsheet

Run from project root:
- Clear caches: `php artisan optimize:clear`
- Check routes: `php artisan route:list`
- Rebuild assets: `npm run build`
- Dev mode: `composer run dev`
- Relink storage: `php artisan storage:link`
- Tail logs: `php artisan pail` (or inspect `storage/logs/laravel.log`)

## 3. Most Likely Debug Scenarios and Fixes

### A) Login works but wrong page/unauthorized
Possible cause:
- Incorrect `role` value in `users` table

Check:
- User role should be `admin` or `pet_owner`

Fix:
- Update user role in DB
- Re-login

### B) Appointment slot conflict
Possible cause:
- Slot already used by pending/confirmed appointment

Fix:
- Choose a free slot
- Explain that this is expected validation behavior

### C) Appointment auto-cancel confusion
Possible cause:
- Past pending/confirmed entries are auto-cancelled by system logic

Fix:
- Use future date/time for demo booking
- Explain auto-cancel rule for no-shows/past schedules

### D) Images/uploads not visible
Possible cause:
- Missing `storage:link` or path issue

Fix:
1. `php artisan storage:link`
2. Refresh page

### E) CSS/JS broken or page looks plain
Possible cause:
- Assets not compiled

Fix:
1. `npm install` (if needed)
2. `npm run build` (or `npm run dev` for live)

### F) DB errors (`SQLSTATE`)
Possible cause:
- Wrong `.env` DB settings or DB service down

Fix:
1. Verify `.env` database values
2. Ensure DB is running and database exists
3. `php artisan config:clear`

## 4. Defense Q&A (Taglish Ready Answers)

Q1: Paano niyo na-handle role security?
- "Gumamit kami ng role-based middleware. Admin routes ay admin lang, and pet owner routes ay pet_owner lang."

Q2: Paano niyo naiiwasan ang double booking?
- "May server-side validation sa date/time slot. Kapag pending or confirmed na existing schedule, hindi na pwede ma-book ulit."

Q3: Ano mangyayari sa missed appointments?
- "May rule kami na past pending/confirmed appointments can be auto-cancelled para malinis ang queue."

Q4: Can client users edit medical records?
- "Hindi po. Read/view access lang sila sa relevant records. Admin lang ang may management controls."

Q5: Paano niyo mina-maintain ang auditability?
- "Meron kaming activity logs module with filters para ma-trace actions by user, action type, and date."

Q6: Ano pa puwedeng i-improve?
- "Pwede pa namin idagdag notifications, advanced reports/analytics, at mobile-first enhancements."

## 5. Emergency Demo Recovery Plan

If live demo fails:
1. Switch to prepared backup account/data.
2. Show the same flow using stable records.
3. If feature-specific issue persists, show screenshot/video evidence.
4. Continue to next module to preserve presentation flow.

Do not panic script:
- "May temporary environment issue lang po. To keep the flow, we’ll proceed with verified data while we briefly explain the expected behavior."

## 6. Team Role Assignment During Debug

- Member 1: Speaks and handles panel communication
- Member 2: Performs UI actions for demo
- Member 3: Monitors terminal/logs
- Member 4: Prepares backup path (screenshots/account/data)

## 7. Final Night Before Checking

- Run full script once end-to-end
- Verify admin and pet owner credentials
- Verify booking, records, inventory, and logs pages
- Export slides to PDF backup
- Keep source zip + DB export in cloud + USB
