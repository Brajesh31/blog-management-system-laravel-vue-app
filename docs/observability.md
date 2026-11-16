# 📈 Observability and Logging

The repository uses Laravel logging configuration and includes Laravel Pail as a development dependency. It does not ship a configured external APM, metrics backend or tracing service.

## Useful signals
- Request volume, status codes and latency by route.
- PHP exceptions and application error rates.
- Database connection failures, slow queries and saturation.
- Queue depth, job duration and failed-job count when queues are used.
- Disk utilization and upload write failures.
- Backup completion and restoration-test outcomes.

## Logging practices
- Keep production debug disabled.
- Use structured context where possible.
- Never log passwords, access tokens, reset links, session cookies, full post bodies or uploaded file content.
- Restrict log read access and define retention/rotation.
- Redact IP addresses or user identifiers where not needed for incident response.
- Avoid exposing stack traces or SQL details to browser responses.

## Health checks
The Laravel bootstrap configures the standard /up health endpoint. This is a liveness-style signal; separately verify DB, mail, queues, filesystem and user journeys.

## Alert response
Every alert should have an owner, a severity, a known safe diagnostic path and an escalation route. Use [Operations](operations.md) and [Backup and Recovery](backup-and-recovery.md) during incidents.
