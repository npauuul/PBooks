const Usuario = require('../models/usuario');
const { generarToken } = require('../config/jwt');

exports.registrar = async (req, res) => {
    try {
        const { username, password } = req.body;
        
        if (!username || !password) {
            return res.status(400).json({ error: 'Nombre de usuario y contraseña son requeridos' });
        }

        const existeUsuario = await Usuario.obtenerPorNombre(username);
        if (existeUsuario) {
            return res.status(400).json({ error: 'El nombre de usuario ya existe' });
        }

        const id = await Usuario.crear(username, password);

        res.status(201).json({ message: 'Usuario registrado exitosamente'});
    } catch (error) {
        res.status(500).json({ error: 'Error al registrar usuario' });
    }
};

exports.login = async (req, res) => {
    try {
        const { username, password } = req.body;
        
        const usuario = await Usuario.verificarCredenciales(username, password);
        if (!usuario) {
            return res.status(401).json({ error: 'Credenciales inválidas' });
        }

        const token = generarToken(usuario);
        res.json({ 
            message: 'Inicio de sesión exitoso',
            token,
            user: {
                id: usuario.id,
                username: usuario.username,
                is_admin: usuario.is_admin
            }
        });
    } catch (error) {
        res.status(500).json({ error: 'Error al iniciar sesión' });
    }
};