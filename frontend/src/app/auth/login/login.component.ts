import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';

@Component({
  standalone: true,
  selector: 'app-login',
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {

  email = '';
  password = '';
  error = '';

  constructor(
    private auth: AuthService,
    private router: Router
  ) {}

  login() {
    this.error = '';

    this.auth.login(this.email, this.password).subscribe({
      next: (res) => {
        const role = res.user.role;

        if (role === 'admin') {
          this.router.navigate(['/admin']);
        } else {
          this.router.navigate(['/author/comics']);
        }// =========================
        // Redirigir según el rol
        // =========================
        if (role === 'admin') {
          this.router.navigate(['/admin']); // admin dashboard
        } else if (role === 'author') {
          this.router.navigate(['/panel/autor/comics']); // autor dashboard
        } else {
          this.router.navigate(['/']); // fallback: home
        }
      },
      error: () => {
        this.error = 'Credenciales incorrectas';
      }
    });
  }
}
