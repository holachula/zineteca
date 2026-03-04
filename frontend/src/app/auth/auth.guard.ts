import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';

/*
authGuard:
Protege rutas privadas, permite acceso si está autenticado.
*/
export const authGuard: CanActivateFn = () => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isAuthenticated()) {
    // Usuario logueado: permite acceder a la ruta privada
    return true;
  }

  // No autenticado: redirige al login
  router.navigate(['/login']);
  return false;
};