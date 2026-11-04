import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';

/*
loginRedirectGuard:
Evita que un usuario logueado abra la página de login.
Si ya está logueado, lo lleva a su dashboard según rol.
*/
export const loginRedirectGuard: CanActivateFn = () => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isAuthenticated()) {
    const role = authService.getUserRole();
    if (role === 'admin') {
      router.navigate(['/admin']);
    } else if (role === 'author') {
      router.navigate(['/panel/autor/comics']);
    }
    return false; // bloquea /login
  }

  return true; // permite abrir /login si no está logueado
};