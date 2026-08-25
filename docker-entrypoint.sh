#!/usr/bin/env sh
set -e

# Fail fast if required DB configuration is missing, instead of booting with an
# empty .env and dying later at the first query (a much harder error to trace).
: "${DB_HOST:?DB_HOST is required}"
: "${DB_USER:?DB_USER is required}"
: "${DB_PASS:?DB_PASS is required}"
: "${DB_NAME:?DB_NAME is required}"

# SMTP is not fatal (the app boots without it), but mail would fail silently.
if [ -z "$SMTP_HOST" ] || [ -z "$SMTP_USERNAME" ] || [ -z "$SMTP_PSW" ]; then
    echo "WARNING: SMTP_* not fully set; outgoing email will fail." >&2
fi

ENV_FILE=/var/www/html/includes/.env

# Emit a double-quoted value with backslash, double-quote and dollar escaped, so
# passwords with spaces, #, quotes or ${...} round-trip through phpdotenv intact.
# (phpdotenv does NOT support shell-style '\'' escaping inside single quotes.)
put() {
    v=$(printf '%s' "$2" | sed -e 's/\\/\\\\/g' -e 's/"/\\"/g' -e 's/\$/\\$/g')
    printf '%s="%s"\n' "$1" "$v"
}

# The file holds credentials: restrict it to the web user only.
umask 077
{
    put DB_HOST "$DB_HOST"
    put DB_USER "$DB_USER"
    put DB_PASS "$DB_PASS"
    put DB_NAME "$DB_NAME"
    echo
    put SMTP_HOST "$SMTP_HOST"
    put SMTP_USERNAME "$SMTP_USERNAME"
    put SMTP_PSW "$SMTP_PSW"
    echo
    put APP_URL "$APP_URL"
} > "$ENV_FILE"
chown www-data:www-data "$ENV_FILE"
chmod 640 "$ENV_FILE"

exec "$@"
