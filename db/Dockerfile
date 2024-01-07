# Use the official MySQL image as the base image
FROM mysql:8.2.0

# Add the SQL scripts from your local _sql/db directory
# to the image's /docker-entrypoint-initdb.d directory
COPY ./db_backup.sql /docker-entrypoint-initdb.d/
