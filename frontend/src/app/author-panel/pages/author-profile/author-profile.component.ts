// author-profile.component.ts

import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthorsService } from '../../../services/authors.service';
import { Author } from '../../../models/author.model';

/*
AUTHOR PROFILE COMPONENT

Permite que el autor edite su perfil:

- nombre
- bio
- redes sociales
- foto de perfil

También permite seleccionar una imagen local
y mostrar un preview antes de subirla.
*/

@Component({
  selector: 'app-author-profile',

  standalone: true,

  imports: [CommonModule, FormsModule],

  templateUrl: './author-profile.component.html',

  styleUrls: ['./author-profile.component.scss']
})
export class AuthorProfileComponent implements OnInit {

  author: Author = {
    nombre: '',
    bio: '',
    instagram: '',
    twitter: '',
    website: ''
  };

  saving = false;

  /*
  Archivo de imagen seleccionado por el usuario
  */
  selectedFile: File | null = null;

  /*
  URL temporal para mostrar preview de imagen
  */
  previewUrl: string | null = null;

  constructor(
    private authorsService: AuthorsService
  ) {}

  ngOnInit(): void {

    /*
    Cargar perfil del autor logueado
    */

    this.authorsService.getMyProfile().subscribe({

      next: (data) => {

        this.author = data;

        /*
        Si el autor ya tiene foto de perfil
        mostramos la imagen desde el backend
        */

        if (data.foto_perfil) {
          this.previewUrl = data.foto_perfil;
        }

      },

      error: (err) => {
        console.error("Error cargando perfil", err);
      }

    });

  }

  /*
  Se ejecuta cuando el usuario selecciona una imagen
  */

  onFileSelected(event: any): void {

    const file = event.target.files[0];

    if (!file) return;

    this.selectedFile = file;

    /*
    Genera un preview temporal de la imagen
    usando FileReader
    */

    const reader = new FileReader();

    reader.onload = () => {
      this.previewUrl = reader.result as string;
    };

    reader.readAsDataURL(file);

  }

  save(): void {

    this.saving = true;

    /*
    Creamos FormData para enviar texto + archivo
    */

    const formData = new FormData();

    formData.append('nombre', this.author.nombre);
    formData.append('bio', this.author.bio || '');
    formData.append('instagram', this.author.instagram || '');
    formData.append('twitter', this.author.twitter || '');
    formData.append('website', this.author.website || '');

    /*
    Si el usuario seleccionó una imagen
    la agregamos al FormData
    */

    if (this.selectedFile) {
      formData.append('foto_perfil', this.selectedFile);
    }

    this.authorsService.updateMyProfile(formData).subscribe({

      next: () => {

        alert("Perfil actualizado");

        this.saving = false;

      },

      error: (err) => {

        console.error("Error actualizando perfil", err);

        this.saving = false;

      }

    });

  }

}