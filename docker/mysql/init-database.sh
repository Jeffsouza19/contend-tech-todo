#!/bin/bash
set -e

# This script is executed when MySQL container starts
# It ensures the database is properly initialized

echo "MySQL initialization script running..."

# Wait for MySQL to be ready
until mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "SELECT 1"; do
  echo "MySQL is not ready yet - waiting..."
  sleep 2
done

echo "MySQL is ready - proceeding with initialization"

# Create database if it doesn't exist
mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS \`$MYSQL_DATABASE\`;"

echo "Database initialization completed successfully"
