import './bootstrap';
/*
 * Bienvenue dans le fichier JavaScript principal de votre application !
 *
 * Ce fichier sera inclus dans la page via la fonction Twig importmap(),
 * qui devrait déjà se trouver dans votre base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

import { Application } from '@hotwired/stimulus';

const application = Application.start();

// Importez vos contrôleurs ici
import HelloController from './controllers/hello_controller';
application.register('hello', HelloController);
