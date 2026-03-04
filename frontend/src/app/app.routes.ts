// src/app/app.routes.ts

// Importamos el tipo Routes desde Angular Router
// Routes es simplemente un arreglo de configuraciones de rutas
import { Routes } from '@angular/router';

// =====================
// IMPORTACIÓN DE COMPONENTES
// =====================

// Componentes principales de la app
import { HomeComponent } from './home/home.component';

// Autores
import { ListaAutoresComponent } from './autores/lista-autores/lista-autores.component';
import { DetalleAutorComponent } from './autores/detalle-autor/detalle-autor.component';

// Comics
import { ListaComicsComponent } from './comics/lista-comics/lista-comics.component';
import { DetalleComicComponent } from './comics/detalle-comic/detalle-comic.component';

// Buscar
import { BuscarComponent } from './buscar/buscar.component';

// Panel de autor
import { MyComicsComponent } from './author-panel/my-comics/my-comics.component';
// src/app/app.routes.ts
import { DetalleComicAutorComponent } from './author-panel/detalle-comic-author/detalle-comic-author.component';
import { ComicFormComponent } from './author-panel/comic-form/comic-form.component';

// Autenticación
import { LoginComponent } from './auth/login/login.component';
import { loginRedirectGuard } from './auth/login-redirect.guard';

// Importar los guards Un Guard es una función que Angular ejecuta antes de permitir que el usuario entre a una ruta.
import { authGuard } from './auth/auth.guard';
import { roleGuard } from './auth/role.guard';


// =====================
// DEFINICIÓN DE RUTAS
// =====================

export const routes: Routes = [

  // =====================
  // HOME
  // =====================
  // Cuando la URL está vacía ( / )
  // Angular muestra el HomeComponent
  { path: '', component: HomeComponent },


  // =====================
  // AUTORES
  // =====================

  // Lista de autores
  // URL: /autores
  { path: 'autores', component: ListaAutoresComponent },

  // Detalle de un autor usando parámetro dinámico
  // URL: /autor/juan-perez
  // :slug es una variable que el componente puede leer
  { path: 'autor/:slug', component: DetalleAutorComponent },

  // Ruta lazy loaded (carga diferida)
  // Solo carga el componente cuando se visita la ruta
  // URL: /admin/agregar-autor
  
  {
  path: 'admin/agregar-autor',
  loadComponent: () =>
    import('./admin/agregar-autor/agregar-autor.component')
      .then(m => m.AgregarAutorComponent),
  canActivate: [authGuard, roleGuard],
  data: { role: 'admin' }
},


  // =====================
  // COMICS
  // =====================

  // Lista de comics
  // URL: /comics
  { path: 'comics', component: ListaComicsComponent },

  // Detalle de un comic por slug
  // URL: /comic/mi-historia
  { path: 'comic/:slug', component: DetalleComicComponent },


  // =====================
  // BUSCAR
  // =====================

  // Página de búsqueda
  // URL: /buscar
  { path: 'buscar', component: BuscarComponent },


  // =====================
  // PANEL AUTOR
  // =====================

  // Lista de comics del autor autenticado
  // URL: /panel/autor/comics
  {
    path: 'panel/autor/comics',
    component: MyComicsComponent,
    canActivate: [authGuard, roleGuard],
    data: { role: 'author' }
  },
// Detalle de comic para autores
{
  path: 'panel/autor/comics/:slug',
  component: DetalleComicAutorComponent,
  canActivate: [authGuard, roleGuard],
  data: { role: 'author' }
},
  // Crear nuevo comic
  // URL: /panel/autor/comics/new
  {
    path: 'panel/autor/comics/new',
    component: ComicFormComponent,
    canActivate: [authGuard, roleGuard],
    data: { role: 'author' }
  },

  // Editar comic por ID
  // URL: /panel/autor/comics/edit/5
  {
    path: 'panel/autor/comics/:slug/editar',
    component: ComicFormComponent,
    canActivate: [authGuard, roleGuard],
    data: { role: 'author' }
  },


  // =====================
  // AUTENTICACIÓN
  // =====================

  // Página de login
 // Login
{
  path: 'login',
  component: LoginComponent,
  canActivate: [loginRedirectGuard] // <--- este evita entrar al login si ya está logueado
},

  // =====================
  // FALLBACK (RUTA 404)
  // =====================

  { path: '**', redirectTo: '' }
];