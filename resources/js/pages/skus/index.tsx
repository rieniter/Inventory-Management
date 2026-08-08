import type { Sku } from "@/types/model"
import type { PaginatedData } from "@/types/paginated";

interface SkusIndexProps {
  skus: PaginatedData<Sku>;
}

export default function Index({skus}:SkusIndexProps){
    return(
        <div>
            {/* 1. Display Data */}
            <ul className="divide-y border rounded-lg mb-6">
                {skus.data.map((sku) => (
                <li key={sku.id} className="p-4 flex justify-between">
                    <span className="font-medium">{sku.code}</span>
                    <span className="text-gray-500 font-mono text-sm">{sku.unit_cost}</span>
                    <span className="text-green-500 font-mono text-sm">{sku.stock}</span>
                </li>

            ))}
            </ul>
        </div>
    );
}
