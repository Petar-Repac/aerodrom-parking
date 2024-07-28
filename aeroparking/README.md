# Environment variables


openssl aes-256-cbc -salt -in .env -out .env.enc -k PASSWORD
openssl aes-256-cbc -d -in .env.enc -out .env -k PASSWORD
