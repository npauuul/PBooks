// models/libro.js
const pool = require('../config/database');

class Libro {
    static async getAll() {
        const [rows] = await pool.query('SELECT * FROM libros');
        return rows;
    }

    static async getByUsuario(id) {
        const [rows] = await pool.query('SELECT * FROM libros where user_id = ?', [id]);
        return rows;
    }

    static async getById(id) {
        const [rows] = await pool.query('SELECT * FROM libros WHERE id = ?', [id]);
        return rows[0];
    }

    static async create(title, author, description, year, category, img_url, user_id) {
        const [result] = await pool.query(
            'INSERT INTO libros (title, author, description, year, category, img_url, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [title, author, description, year, category, img_url, user_id]
        );
        return result.insertId;
    }

    static async update(id, title, author, description, year, category, img_url) {
        const [result] = await pool.query(
            'UPDATE libros SET title = ?, author = ?, description = ?, year = ?, category = ?, img_url = ? WHERE id = ?',
            [title, author, description, year, category, img_url, id]
        );
        return result.affectedRows;
    }

    static async delete(id) {
        const [result] = await pool.query('DELETE FROM libros WHERE id = ?', [id]);
        return result.affectedRows;
    }
}

module.exports = Libro;