import { AttributeList } from "../../entities/attribute/ui/AttributeList";
import { CreateAttributeForm } from "../../features/attribute/create/CreateAttributeForm";

export function AttributeManagement() {
  return (
    <section className="space-y-6">
      <header>
        <h1 className="text-3xl font-bold">Attributes</h1>
        <p className="text-slate-600">
          Manage product attributes and variant axes.
        </p>
      </header>

      <CreateAttributeForm />
      <AttributeList />
    </section>
  );
}
