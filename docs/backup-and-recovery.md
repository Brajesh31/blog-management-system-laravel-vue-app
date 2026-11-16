# 💾 Backup and Recovery

This guide defines a safe operational baseline. No automated backup provider or tested recovery-time objective is included in this repository.

## What must be protected

- Relational database contents, schema and migration history.
- Uploaded media under the filesystem disk used by the application.
- Protected environment configuration and application key, stored separately from source code.
- Release identifiers and dependency lockfiles needed to rebuild the deployed application.

A database dump alone may not include the images referenced by post records.

## Backup principles

1. Use a least-privilege backup identity.
2. Encrypt backup files where appropriate and restrict access.
3. Store backups separately from the application host.
4. Define retention and deletion periods.
5. Record backup time, source environment and commit/release identifier.
6. Test restoration periodically in an isolated environment.

## Example MySQL backup commands

Use only in an authorized environment and protect the output file:

```bash
mysqldump --single-transaction --routines --triggers \
  -h "$DB_HOST" -u "$BACKUP_USER" -p "$DB_DATABASE" > database-backup.sql
```

Restore into a newly created isolated database, not over production:

```bash
mysql -h "$DB_HOST" -u "$RESTORE_USER" -p "$RESTORE_DATABASE" < database-backup.sql
```

The exact command flags, credentials and storage target must be adapted to the database engine and hosting provider. Never put passwords directly into shell history or source files.

## Media backup

Back up the actual directory behind the configured disk. Confirm where the public disk resolves in Laravel before copying data. Preserve directory structure and file permissions. Include upload files in restore validation and test whether the public storage link points to the intended storage directory.

## Restore drill

- [ ] Restore database into an isolated environment.
- [ ] Confirm migrations and application version compatibility.
- [ ] Restore media and verify referenced paths exist.
- [ ] Set the correct environment and application key.
- [ ] Verify login and account access.
- [ ] Verify representative post records and media.
- [ ] Verify queue/session/cache behavior.
- [ ] Record recovery duration and gaps.

## Recovery objectives

The service owner must define recovery time objective (RTO) and recovery point objective (RPO) based on business needs. This repository currently publishes neither. See [Operations](operations.md).
