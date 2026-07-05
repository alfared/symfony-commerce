import { useEffect, useState } from 'react';
import { create{{ Entity }}, get{{ Entity }}s } from '@/entities/{{ entityKebab }}/api/{{ entityKebab }}Api';
import type { {{ Entity }} } from '@/entities/{{ entityKebab }}/model/{{ entityKebab }}';
import type { Create{{ Entity }}Payload } from '@/entities/{{ entityKebab }}/model/{{ entityKebab }}.dto';
import { {{ Entity }}List } from '@/entities/{{ entityKebab }}/ui/{{ Entity }}List';
import { Create{{ Entity }}Form } from '@/features/{{ entityKebab }}/create/Create{{ Entity }}Form';

export function {{ Entity }}Management {
    const [items, setItems] = useState<{{ Entity}}[]>([]);

    useEffect(() => {
        get{{ Entity }}s().then(setItems);
    }, []);

    async function handleCreate(payload: Create{{ Entity }}Payload) {
         const item = await create{{ Entity }}(payload);
         setItems((current) => [item, ...current]);
    }

    return (
        <section className="grid gap-6">
            <Create{{ Entity }}Form onSubmit{handleCreate} />
            <{{ Entity }}List items={items} />
        </section>
    );
}