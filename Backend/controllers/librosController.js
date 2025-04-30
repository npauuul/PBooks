// controllers/librosController.js
const Libro = require('../models/libro');

exports.getAllLibros = async (req, res) => {
    try {
        let libros;
        if (req.user.esAdmin === 1) {
            libros = await Libro.getAll();
        } else {
            libros = await Libro.getByUsuario(req.user.id);
        }
        res.json(libros);
    } catch (error) {
        res.status(500).json({ error: 'Error al obtener libros' });
    }
};

exports.getLibroById = async (req, res) => {
    try {
        const libro = await Libro.getById(req.params.id);
        if (!libro) {
            return res.status(404).json({ error: 'Libro no encontrado' });
        }
        res.json(libro);
    } catch (error) {
        res.status(500).json({ error: 'Error al obtener el libro' });
    }
};

exports.createLibro = async (req, res) => {
    try {
        const { title, author, description, year, category, img_url } = req.body;
        
        const usuario_id = req.user.id;

        const id = await Libro.create(title, author, description, year, category, img_url, usuario_id);
        res.status(201).json({ id, title, author, description, year, category, img_url, usuario_id, message: "Libro creado correctamente." });
    } catch (error) {
        res.status(500).json({ error: 'Error al crear el libro' + req.body });
    }
};

exports.updateLibro = async (req, res) => {
    try {
        const { title, author, description, year, category, img_url } = req.body;
        const affectedRows = await Libro.update(
            req.params.id, 
            title, 
            author,
            description,
            year,
            category,
            img_url,
        );
        
        if (affectedRows === 0) {
            return res.status(404).json({ error: 'Libro no encontrado' });
        }
        
        res.json({ message: 'Libro actualizado correctamente' });
    } catch (error) {
        res.status(500).json({ error: 'Error al actualizar el libro' + error });
    }
};

exports.deleteLibro = async (req, res) => {
    try {
        const affectedRows = await Libro.delete(req.params.id);
        if (affectedRows === 0) {
            return res.status(404).json({ error: 'Libro no encontrado' });
        }
        res.json({ message: 'Libro eliminado correctamente' });
    } catch (error) {
        res.status(500).json({ error: 'Error al eliminar el libro' });
    }
};