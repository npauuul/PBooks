const { verificarToken } = require('../config/jwt');

const autenticar = (req, res, next) => {
    const token = req.header('Authorization')?.replace('Bearer ', '');
    
    if (!token) {
        return res.status(401).json({ error: 'Acceso no autorizado' });
    }

    try {
        const decoded = verificarToken(token);
        req.user = decoded;
        next();
    } catch (error) {
        res.status(401).json({ error: 'Token inválido' });
    }
};

const esAdmin = (req, res, next) => {
    if (!req.usuario?.is_admin) {
        return res.status(403).json({ error: 'Acceso prohibido' });
    }
    next();
};

module.exports = { autenticar, esAdmin };