import { registerReactControllerComponents } from '@symfony/ux-react';
import './bootstrap.js';
import { session } from '@hotwired/turbo';
import './styles/app.css';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

session.start();
