const express  = require('express');
const http     = require('http');
const path     = require('path');
const cors     = require('cors');

class Server {

    constructor() {

        this.app  = express();
        this.port = process.env.PORT;
        this.paths = {
            'auth': '/api/auth',
            'usuarios': '/api/usuarios',            
        };

        // Http server
        this.server = http.createServer( this.app );
            
    }

    middlewares() {
        //para leer jsons
        this.app.use(express.json());
        
        // Desplegar el directorio público
        this.app.use( express.static( path.resolve( __dirname, '../public' ) ) );

        // CORS
        this.app.use( cors() );

        //Routes
        this.app.use(this.paths.auth, require('../routes/auth.routes'));
        this.app.use(this.paths.usuarios, require('../routes/usuarios.routes'));                
    }    

    async execute(){
        try {            
            console.log('Connection has been established successfully.');
          } catch (error) {
            console.error('Unable to connect to the database:', error);
        }

        // Inicializar Middlewares
        this.middlewares();

        // Inicializar Server
        this.server.listen( this.port, () => {
            console.log('Server corriendo en puerto:', this.port );
        });
    }

}


module.exports = Server;