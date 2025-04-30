const express = require('express');
const router = express.Router();
const librosController = require('../controllers/librosController');
const { autenticar, esAdmin } = require('../middlewares/authMiddleware');

router.use(autenticar);

router.get('/', librosController.getAllLibros);
router.post('/', librosController.createLibro);
router.get('/:id', librosController.getLibroById);
router.put('/:id', librosController.updateLibro);
router.delete('/:id', librosController.deleteLibro);

router.get('/todos', esAdmin, librosController.getAllLibros);

module.exports = router;