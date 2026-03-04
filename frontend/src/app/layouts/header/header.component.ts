// frontend/src/app/layouts/header/header.component.ts
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; // para *ngIf, *ngFor
import { RouterModule } from '@angular/router'; // para routerLink
import { AuthService } from '../../auth/auth.service';

@Component({
  selector: 'app-header',
  standalone: true, // si estás usando Standalone Components
  imports: [CommonModule, RouterModule], // <-- aquí
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent {
  constructor(public auth: AuthService) {}

  isLoggedIn() {
    return this.auth.isLoggedIn();
  }

  logout() {
    this.auth.logout();
  }
}