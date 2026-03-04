import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AdminService } from '../../services/admin.service';

@Component({
  selector: 'app-agregar-autor',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './agregar-autor.component.html',
  styleUrls: ['./agregar-autor.component.scss']
})
export class AgregarAutorComponent {

  autor = {
    nombre: '',
    estado: '',
    bio: ''
  };

  comics: any[] = [
    { titulo: '', descripcion: '' }
  ];

  constructor(private adminService: AdminService) {}

  agregarComic() {
    this.comics.push({ titulo: '', descripcion: '' });
  }

  eliminarComic(i: number) {
    this.comics.splice(i, 1);
  }

  guardar() {
    const payload = {
      ...this.autor,
      comics: this.comics.filter(c => c.titulo.trim() !== '')
    };

    this.adminService.crearAutor(payload).subscribe({
      next: (resp) => {
        alert('Autor creado con éxito');
        console.log(resp);
      },
      error: (err) => {
        console.error(err);
        alert('Error al crear autor');
      }
    });
  }
}
