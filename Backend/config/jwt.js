const jwt = require('jsonwebtoken');
require('dotenv').config();

const generarToken = (user) => {
    return jwt.sign(
        { id: user.id, esAdmin: user.is_admin },
        process.env.JWT_SECRET,
        { expiresIn: '8h' }
    );
};

const verificarToken = (token) => {
    return jwt.verify(token, process.env.JWT_SECRET);
};

module.exports = { generarToken, verificarToken };