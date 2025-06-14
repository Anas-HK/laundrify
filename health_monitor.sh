#!/bin/bash

echo "[$(date)] Starting health check..."

# Check database container
echo "[$(date)] Checking database container health..."
if ! docker exec laundrify-db mysqladmin ping -h localhost --silent; then
  echo "[$(date)] Database container unhealthy, restarting..."
  docker restart laundrify-db
  sleep 20
  echo "[$(date)] Database container restarted."
else
  echo "[$(date)] Database container health OK."
fi

# Check web app container
echo "[$(date)] Checking web application container health..."
if ! docker exec laundrify-app curl -s http://localhost/health.php > /dev/null; then
  echo "[$(date)] Web application container unhealthy, restarting..."
  docker restart laundrify-app
  echo "[$(date)] Web application container restarted."
else
  echo "[$(date)] Web application container health OK."
fi

echo "[$(date)] Health check completed." 