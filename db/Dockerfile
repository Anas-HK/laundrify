FROM mysql:8

ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=laundrify

COPY laundrify.sql /docker-entrypoint-initdb.d/

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD mysqladmin ping -h localhost -u root -p${MYSQL_ROOT_PASSWORD} || exit 1

# Expose MySQL port
EXPOSE 3306