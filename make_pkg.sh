#!/bin/bash

find . -name '*.php' -exec dos2unix {} \;
find . -name '*.xml' -exec dos2unix {} \;

if [ ! -d ./dist ]; then mkdir dist; fi;

version=$(grep '<version>' mod_bis_filter.xml | sed -e 's/<[a-z\/]*>//g' | sed -e 's/ *//g')
rm dist/module_bis_filter*.zip
zip -r module_bis_filter-${version}-j3X.zip tmpl js css helper.php cs-CZ.* en-GB.*  mod_bis_filter.php mod_bis_filter.xml index.html
mv module_bis_filter-${version}*.zip dist/
