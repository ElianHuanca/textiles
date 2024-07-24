const pool = require('../database/database');

const obtenerEmpresas = async (req, res) => {
    try {
        const results = await pool.query('SELECT * from empresas WHERE estado = true');
        console.log('empresas:', results.rows);        
        return res.json(results.rows);
    } catch (error) {
        console.log('Error:', error);
        res.status(500).json({error:"Error al obtener Empresas", message: error.message});
    }
}

const obtenerEmpresa = async (req, res) => {
    try {
        const { id } = req.params;
        const results = await pool.query('SELECT * from empresas WHERE id = $1 and estado = true', [id]);
        if(results.rows.length === 0){
            console.log('Empresa no encontrada');
            return res.status(404).json({error:"Empresa no encontrada"});
        }
        console.log('Empresa:', results.rows[0]);
        return res.json(results.rows[0]);
    } catch (error) {
        console.log('Error:', error);
        res.status(500).json({error:"Error al obtener Empresa", message: error.message});
    }
}

module.exports = {
    obtenerEmpresas,
    obtenerEmpresa
}