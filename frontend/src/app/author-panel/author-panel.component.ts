// src/app/author-panel/author-panel.component.ts

import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

/*
AUTHOR PANEL COMPONENT

Este componente es el LAYOUT del panel de autor.

Un layout es una estructura visual que contiene
otras páginas internas.

Ejemplo de páginas que se renderizan aquí:

/panel/autor/comics
/panel/autor/comics/new
/panel/autor/comics/:slug
/panel/autor/perfil

Angular insertará esas páginas en <router-outlet>.
*/

@Component({
  selector: 'app-author-panel',

  standalone: true,

  imports: [CommonModule, RouterModule],

  templateUrl: './author-panel.component.html',

  styleUrls: ['./author-panel.component.scss']
})
export class AuthorPanelComponent {}