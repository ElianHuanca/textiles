const pool = require('../database/database');
const bcryptjs = require('bcryptjs');

const obtenerUsuarios = async (req, res) => {
    try {
        const results = await pool.query('SELECT * from usuarios where estado = true');
        console.log('usuarios:', results.rows[0]);
        return res.json(results.rows);
    } catch(error){ 
        console.log('Error:', error);
        res.status(500).json({error:"Error al obtener Usuarios", message: error.message});
    }
}

const obtenerUsuario = async (req, res) => {
    try {
        const { id } = req.params;
        const results = await pool.query('SELECT * from usuarios WHERE id = $1 and estado = true', [id]);
        if(results.rows.length === 0){
            console.log('Usuario no encontrado');
            return res.status(404).json({error:"Usuario no encontrado"});
        }
        console.log('Usuario:', results.rows[0]);
        return res.json(results.rows[0]);
    } catch (error) {
        console.log('Error:', error);
        res.status(500).json({error:"Error al obtener Usuario", message: error.message});
    }
}

const crearUsuario = async (req, res) => {
    try {
        const { idempresa } = req.params;
        const { nombre, correo, password, rol,meta } = req.body;        
        const salt = bcryptjs.genSaltSync();
        const pass = bcryptjs.hashSync( password, salt );
        const results = await pool.query('INSERT INTO usuarios (nombre, correo, password, rol ,meta ,idempresa ) VALUES ($1, $2, $3, $4, $5, $6 ) RETURNING *', [nombre, correo, pass, rol,meta,idempresa]);
        console.log('Usuario creado:', results.rows[0]);
        return res.json(results.rows[0]);
    } catch (error) {
        console.log('Error:', error);
        res.status(500).json({error:"Error al crear Usuario", message: error.message});
    }
}

module.exports = {
    obtenerUsuarios,
    obtenerUsuario,
    crearUsuario
};