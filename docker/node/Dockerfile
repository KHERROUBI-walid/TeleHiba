# docker/node/Dockerfile
FROM node:24.2

WORKDIR /var/www/html

# Copier package.json et package-lock.json
COPY package*.json ./

# Installer les dépendances npm
RUN npm install

# Copier tout le projet
COPY . .

# Par défaut, ne rien faire
CMD ["bash"]
