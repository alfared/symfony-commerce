export type Product = {
  id: number;
  iri: string;
  code: string;
  name: string;
  slug: string;
  description: string | null;
  enabled: boolean;
};