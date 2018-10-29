FROM csunmetalab/environment:base

# Add Yarn Debian Repo
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
 && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
 && apt-get update \
# Update and install additional dependencies/packages
  && apt-get update && apt-get install -y \
  php7.2 \
  wget \
  yarn \
# Install NVM
  && wget -qO- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
# Define Bashrc source
  && . ~/.bashrc \
# Install NPM v9.11.2
  && nvm install 9.11.2 && npm install \
# Clean image
  && npm cache clean --force && apt-get clean && apt-get autoremove && rm -rf /var/lib/apt/lists/* \
