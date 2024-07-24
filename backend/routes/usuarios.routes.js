const { Router } = require("express");
const router = Router();

const controller = require("../controllers/usuarios");

router.get('', controller.obtenerUsuarios);
router.get('/:id', controller.obtenerUsuario);
module.exports = router;