#!/bin/bash

# Creates secrets files with placeholders
mkdir -p secrets

echo "CHANGE_ME_db_password" > secrets/db_password.txt
echo "CHANGE_ME_root_password" > secrets/db_root_password.txt
echo "CHANGE_ME_wp_admin_user" > secrets/wp_admin_user.txt
echo "CHANGE_ME_wp_admin_password" > secrets/wp_admin_password.txt

echo "Update secrets files with credentials"
echo "WordPress admin username cannot contain admin/Admin/administrator/Administrator"
