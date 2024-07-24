const { Pool } = require('postgres-pool');
require('dotenv').config();

const database = process.env.DATABASE;
const username = process.env.DB_USERNAME;
const password = process.env.PASSWORD;
const host = process.env.HOST;
const dbport = process.env.DB_PORT ? process.env.DB_PORT : 5432;

const pool = new Pool({
  connectionString: `postgres://${username}:${password}@${host}:${dbport}/${database}`
});

module.exports = pool;
