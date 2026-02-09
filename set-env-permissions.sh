#!/bin/bash
# Auto-Security Script for Laravel Project
# Automatically sets proper permissions for .env and other sensitive files
# Run this script immediately after uploading to any cPanel/hosting

echo "🔒 Laravel Security Auto-Setup Script"
echo "======================================"

# Function to set .env permissions
set_env_permissions() {
    if [ -f ".env" ]; then
        chmod 600 .env
        echo "✅ .env file permissions set to 600 (owner read/write only)"
        echo "   Current permissions: $(ls -la .env | awk '{print $1, $3, $4, $9}')"
    else
        echo "❌ .env file not found in current directory"
        echo "   Current directory: $(pwd)"
        echo "   Available files:"
        ls -la | grep -E "\.(env|php)$"
    fi
}

# Function to set storage permissions
set_storage_permissions() {
    if [ -d "storage" ]; then
        chmod -R 755 storage/
        chmod -R 775 storage/logs/
        chmod -R 775 storage/framework/
        echo "✅ Storage directory permissions set"
    fi

    if [ -d "bootstrap/cache" ]; then
        chmod -R 755 bootstrap/cache/
        echo "✅ Bootstrap cache permissions set"
    fi
}

# Function to secure other sensitive files
secure_sensitive_files() {
    # Secure composer files
    if [ -f "composer.json" ]; then
        chmod 644 composer.json
    fi
    if [ -f "composer.lock" ]; then
        chmod 644 composer.lock
    fi

    # Secure package.json
    if [ -f "package.json" ]; then
        chmod 644 package.json
    fi

    # Secure artisan
    if [ -f "artisan" ]; then
        chmod 755 artisan
    fi

    echo "✅ Other sensitive files secured"
}

# Main execution
echo "Starting auto-security setup..."
echo ""

set_env_permissions
set_storage_permissions
secure_sensitive_files

echo ""
echo "🎉 Security setup completed!"
echo ""
echo "IMPORTANT: Verify .env is not accessible via web:"
echo "Try accessing: https://yourdomain.com/.env"
echo "It should return 403 Forbidden or 404 Not Found"
echo ""
echo "To run this script automatically on upload, add this to your deployment process:"
echo "bash set-env-permissions.sh"
