#!/bin/bash

# Creates secrets files with placeholders
mkdir -p secrets

echo "CHANGE_ME" > secrets/db_password.txt
echo "CHANGE_ME" > secrets/db_root_password.txt
echo "CHANGE_ME" > secrets/wp_admin_user.txt
echo "CHANGE_ME" > secrets/wp_admin_password.txt

echo "Update secrets files with credentials"
echo "WordPress admin username cannot contain admin/Admin/administrator/Administrator"
