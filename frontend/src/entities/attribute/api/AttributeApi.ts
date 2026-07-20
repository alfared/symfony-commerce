import type { Attribute } from "../model/attribute";
import type {
  CreateAttributeDto,
  CreateAttributeResponse,
} from "../model/attribute.dto";

const API_URL =
  import.meta.env.VITE_API_URL ?? "http://symf.commerce.local:8081";

async function getErrorMessage(response: Response): Promise<string> {
  const payload = (await response.json().catch(() => null)) as {
    error?: string;
    message?: string;
  } | null;

  return (
    payload?.error ??
    payload?.message ??
    `Request failed with status ${response.status}`
  );
}

export async function getAttributes(): Promise<Attribute[]> {
  const response = await fetch(`${API_URL}/api/attributes`, {
    headers: {
      Accept: "application/json",
    },
  });

  if (!response.ok) {
    throw new Error("Failed to load attributes.");
  }

  return response.json() as Promise<Attribute[]>;
}

export async function createAttribute(
  payload: CreateAttributeDto,
): Promise<CreateAttributeResponse> {
  const response = await fetch(`${API_URL}/api/attributes`, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });

  if (!response.ok) {
    throw new Error(await getErrorMessage(response));
  }

  return response.json() as Promise<CreateAttributeResponse>;
}
