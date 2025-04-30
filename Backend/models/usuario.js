const pool = require('../config/database');
const bcrypt = require('bcrypt');

class Usuario {
    static async crear(username, password, is_admin = 0) {
        const hashedPassword = await bcrypt.hash(password, 10);
        const [result] = await pool.query(
            'INSERT INTO usuarios (username, password, is_admin) VALUES (?, ?, ?)',
            [username, hashedPassword, is_admin]
        );
        return result.insertId;
    }

    static async obtenerPorNombre(username) {
        const [rows] = await pool.query(
            'SELECT * FROM usuarios WHERE username = ?',
            [username]
        );
        return rows[0];
    }

    static async verificarCredenciales(username, password) {
        const usuario = await this.obtenerPorNombre(username);
        if (!usuario) return null;
        
        const valido = await bcrypt.compare(password, usuario.password);
        return valido ? usuario : null;
    }
}

module.exports = Usuario;