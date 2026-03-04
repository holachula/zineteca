export interface Comic {
  id: number;
  titulo: string;
  slug: string;
  descripcion: string;
  anio: number;
  portada: string | null;
  portada_url: string | null;
}