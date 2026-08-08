export interface Category {
  id: number;
  name: string;
  slug: string;
}

export interface Sku {
  id: number;
  product_id: number;
  code: string;
  unit_cost: number;
  stock: number;
}

export interface Product{
  id: number;
  category_id: number;
  name: string;
  description?: string;
  created_at: string;
  category?: Category;
  skus: Sku[];
}