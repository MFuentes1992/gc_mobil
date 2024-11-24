!/bin/bash
// cehckout main branch
git checkout main
// pull latest changes
git pull origin main
cd ../constants
rm constants.php
cp /QA/constants.php constants.php
cd ../
scp -r . u579469339.dasgalu_net@dasgalu.net:/api_movil_gc/
git checkout .
echo "Successfully deployed to QA!"