# VetConnect V2 Admin Guide

Document Control
- Project Title: VetConnect V2
- Audience: Admin Users (Clinic Personnel)
- Version: 1.0
- Date: [Insert date]
- Prepared by: [Insert names]

## 1. Purpose

This guide explains how admin users operate and maintain VetConnect V2, including:
- User account management
- Pet and appointment management
- Medical and vaccination record management
- Medicine inventory monitoring
- Activity log review

## 2. Admin Access

Only users with role `admin` can open admin pages.

Admin login process:
1. Open login page.
2. Enter admin credentials.
3. Click **Log in**.
4. System redirects to **Admin Dashboard**.

If role is not `admin`, user cannot access admin routes.

## 3. Admin Dashboard

The dashboard provides:
- High-level statistics
- Charts and visual summaries
- Recent operational activity

Use dashboard as daily overview before handling transactions.

## 4. User Management

### 4.1 View users
1. Open **Users** module.
2. Review all registered users and roles.

### 4.2 Create user
1. Click **Add User**.
2. Fill required details (name, email, password, role).
3. Save the account.

### 4.3 Edit user
1. Select user.
2. Click **Edit**.
3. Update details or role.
4. Save changes.

### 4.4 Delete user
1. Select user.
2. Click **Delete**.
3. Confirm deletion.

Best practice:
- Do not delete active accounts without backup review.

## 5. Pet Management (Admin Side)

### 5.1 View and search pets
1. Open **Pets** module.
2. Use search/filter fields as needed.

### 5.2 Add pet
1. Click **Create Pet**.
2. Assign an owner (`pet_owner` account).
3. Enter pet details.
4. Save.

### 5.3 Edit or remove pet
1. Open pet record.
2. Edit fields as needed, or delete if appropriate.

Data validation reminder:
- Verify owner assignment before saving.

## 6. Appointment Management

### 6.1 View appointments
Admin appointments page includes:
- Upcoming list
- Search support
- Today's queue section

### 6.2 Create appointment
1. Click **Create Appointment**.
2. Select owner, pet, date, time, and service details.
3. Save.

### 6.3 Edit appointment
1. Open an appointment.
2. Update date/time/details.
3. Save changes.

### 6.4 Check-in by reference
1. Use reference check-in field/tool.
2. Enter appointment reference code.
3. Submit to mark check-in/status update.

### 6.5 Cancellation and no-show behavior
- Manual cancellation is available.
- System may auto-cancel past pending/confirmed entries based on logic.

## 7. Medical Records Management

### 7.1 Create medical record
1. Open **Medical Records**.
2. Click **Add**.
3. Select pet and assigned veterinarian/admin.
4. Enter findings, diagnosis, treatment, notes.
5. Save.

### 7.2 Update or delete records
1. Locate record.
2. Edit or delete as authorized.

Best practice:
- Keep entries objective and complete for continuity of care.

## 8. Vaccination Records Management

### 8.1 Add vaccination record
1. Open **Vaccination Records**.
2. Click **Add**.
3. Select pet and vaccine details.
4. Set status and date.
5. Save.

### 8.2 Update status
1. Edit existing record.
2. Update status according to vaccination progress.
3. Save.

### 8.3 Delete record
Use only when duplicate or invalid entry is confirmed.

## 9. Medicine Inventory Management

Admin can:
- Add medicines
- Edit stock, expiry, and details
- Delete invalid entries
- Monitor stock state indicators (expired, out-of-stock, low stock, available)

Daily routine:
1. Check inventory list.
2. Resolve low/out stocks.
3. Review expired items for replacement and disposal process.

## 10. Global Search

Admin search can retrieve:
- Pet records
- Owner/user accounts

Use search before creating new entries to avoid duplicates.

## 11. Activity Logs and Audit

1. Open **Activity Logs**.
2. Filter by user, action, date, or keyword.
3. Review significant actions for accountability.

Use logs for:
- Incident review
- Data change tracing
- Operational monitoring

## 12. Security and Maintenance

- Keep admin credentials confidential.
- Use strong and unique passwords.
- Log out after each session on shared devices.
- Regularly back up database and uploaded files.
- Verify storage links and file permissions after deployment updates.

## 13. Troubleshooting

- Cannot access admin pages
  - Confirm user role is `admin`.

- Uploaded photos not visible
  - Check storage configuration/symlink and public path access.

- Appointment slot conflict
  - Slot already booked by another pending/confirmed appointment.

- Unexpected appointment cancellation
  - Check date/time and auto-cancel logic for past appointments.

## 14. Operational Checklist (Daily)

1. Review dashboard KPIs.
2. Check today's appointments and queue.
3. Process updates to pets and records.
4. Verify medicine inventory status.
5. Review critical activity logs.
6. Backup data at end of day (if scheduled manually).

## 15. Screenshots Section (To Attach Before Submission)

Attach and caption screenshots for:
1. Admin dashboard
2. Users module
3. Pets module
4. Appointments page and check-in feature
5. Medical records page
6. Vaccination records page
7. Medicines inventory page
8. Activity logs page
9. Search results page
