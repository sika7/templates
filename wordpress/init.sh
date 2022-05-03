#!/bin/bash

apt update
# apt -y upgrade
apt -y install libssl-dev libreadline-dev
apt -y install git vim curl


# ruby install
git clone https://github.com/sstephenson/rbenv.git ~/.rbenv
git clone https://github.com/sstephenson/ruby-build.git ~/.rbenv/plugins/ruby-build
echo 'export PATH="$HOME/.rbenv/bin:$PATH"' >> ~/.bash_profile
echo 'eval "$(rbenv init -)"' >> ~/.bash_profile
. ~/.bash_profile
git clone https://github.com/rbenv/ruby-build.git ~/.rbenv/plugins/ruby-build
rbenv install 2.4.2
rbenv global 2.4.2
rbenv rehash

# wordmove install
gem install wordmove


# wp-cli install
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

wp core install --url=http://localhost:9000/ --title=test --admin_user=7code --admin_password=7code-90911 --admin_email=nagaiwasann@gmail.com --allow-root

wp core language install ja --activate --allow-root
wp plugin install wp-multibyte-patch --activate --allow-root

# starter　theme
# wp scaffold _s theme --allow-root

# wp plugins uninstall
wp plugin delete hello --allow-root

# wp plugin install
wp plugin install --allow-root \
all-in-one-wp-migration \
wp-pagenavi \
wordpress-seo \
custom-field-suite \
custom-post-type-permalinks \
intuitive-custom-post-order \
mw-wp-form \
social-networks-auto-poster-facebook-twitter-g \
wp-admin-ui-customize \
google-analytics-dashboard-for-wp \
siteguard


# wp plugin activate
wp plugin activate --allow-root \
wp-pagenavi \
wordpress-seo \
custom-field-suite \
custom-post-type-permalinks \
intuitive-custom-post-order


# theme-unit-test import
git clone https://github.com/jawordpressorg/theme-test-data-ja.git /tmp/wp-test/
wp plugin install wordpress-importer --activate --allow-root
wp import /tmp/wp-test/wordpress-theme-test-date-ja.xml --authors=create --allow-root



# いらないファイルを削除
rm -rf /var/lib/apt/lists/*
