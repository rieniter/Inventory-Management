import {Link} from "@inertiajs/react"
import type { Category } from "@/types/model"
import type { PaginatedData } from "@/types/paginated";

interface CategoriesIndexProps {
  categories: PaginatedData<Category>;
}

export default function Index({categories}:CategoriesIndexProps){
    return(
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Categories</h1>

      {/* 1. Display Data */}
      <ul className="divide-y border rounded-lg mb-6">
        {categories.data.map((category) => (
          <li key={category.id} className="p-4 flex justify-between">
            <span className="font-medium">{category.name}</span>
            <span className="text-gray-500 font-mono text-sm">{category.slug}</span>
          </li>
        ))}
      </ul>

      {/* 2. Render Pagination Links */}
      <div className="flex gap-2 flex-wrap">
        {categories.links.map((link, key) =>
          link.url ? (
            <Link
              key={key}
              href={link.url}
              dangerouslySetInnerHTML={{ __html: link.label }}
              className={`px-3 py-1 border rounded text-sm ${
                link.active ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
              }`}
            />
          ) : (
            <span
              key={key}
              dangerouslySetInnerHTML={{ __html: link.label }}
              className="px-3 py-1 border rounded text-sm text-gray-400 pointer-events-none"
            />
          )
        )}
      </div>
    </div>
    );
}