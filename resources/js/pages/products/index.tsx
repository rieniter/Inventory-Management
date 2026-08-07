import {Link, usePage} from "@inertiajs/react"
import { Product } from "@/types/model";
import { PaginatedData } from "@/types/paginated";


interface ProductsIndexProps {
  products: PaginatedData<Product>;
}

export default function Index({ products }: ProductsIndexProps) {
  return (
    <div className="p-6 max-w-7xl mx-auto">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-bold text-gray-900">Products</h1>
        <Link
          href="/products/create"
          className="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md shadow-sm text-sm"
        >
          Add Product
        </Link>
      </div>

      <div className="bg-white shadow rounded-lg overflow-hidden">
        <table className="w-full text-left border-collapse">
          <thead className="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase text-gray-600">
            <tr>
              <th className="px-6 py-3">ID</th>
              <th className="px-6 py-3">Name</th>
              <th className="px-6 py-3">Category</th>
              <th className="px-6 py-3">SKUs Count</th>
              <th className="px-6 py-3 text-right">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-200 text-sm">
            {products.data.length === 0 ? (
              <tr>
                <td colSpan={5} className="px-6 py-4 text-center text-gray-500">
                  No products found.
                </td>
              </tr>
            ) : (
              products.data.map((product: Product) => (
                <tr key={product.id} className="hover:bg-gray-50">
                  <td className="px-6 py-4 font-mono text-gray-500">{product.id}</td>
                  <td className="px-6 py-4 font-medium text-gray-900">{product.name}</td>
                  <td className="px-6 py-4 text-gray-600">
                    {product.category?.name ?? 'Uncategorized'}
                  </td>
                  <td className="px-6 py-4 text-gray-600">
                    {product.skus.length} variant{product.skus.length !== 1 ? 's' : ''}
                  </td>
                  <td className="px-6 py-4 text-right space-x-3">
                    <Link
                      href={`/products/${product.id}/edit`}
                      className="text-indigo-600 hover:text-indigo-900 font-medium"
                    >
                      Edit
                    </Link>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>

      {/* Pagination Links */}
      <div className="mt-4 flex justify-end space-x-1">
        {products.links.map((link, index) => (
          <Link
            key={index}
            href={link.url ?? '#'}
            dangerouslySetInnerHTML={{ __html: link.label }}
            className={`px-3 py-1 text-sm rounded ${
              link.active
                ? 'bg-indigo-600 text-white'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            } ${!link.url ? 'opacity-50 pointer-events-none' : ''}`}
          />
        ))}
      </div>
    </div>
  );
}