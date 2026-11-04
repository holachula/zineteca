import { inject } from '@angular/core';
import { CanActivateFn, Router, ActivatedRouteSnapshot } from '@angular/router';
import { AuthService } from './auth.service';

/*
ActivatedRouteSnapshot:
Contiene información de la ruta que se está intentando abrir.
Ahí podemos leer metadata como el role esperado.
*/

export const roleGuard: CanActivateFn = (route: ActivatedRouteSnapshot) => {

  const authService = inject(AuthService);
  const router = inject(Router);

  // El rol esperado lo leeremos desde la ruta
  const expectedRole = route.data['role'];

  if (!authService.isAuthenticated()) {
    router.navigate(['/login']);
    return false;
  }

  if (authService.getUserRole() === expectedRole) {
    return true;
  }

  // Si el rol no coincide, lo mandamos al home
  router.navigate(['/']);
  return false;
};