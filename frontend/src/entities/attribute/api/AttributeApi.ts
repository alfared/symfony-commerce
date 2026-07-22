import type { Attribute } from "../model/attribute";
import type {
  CreateAttributeDto,
  CreateAttributeResponse,
  UpdateAttributeDto,
} from "../model/attribute.dto";

const API_URL =
  import.meta.env.VITE_API_URL ?? "http://symf.commerce.local:8081";

async function getErrorMessage(response: Response): Promise<string> {
  const payload = (await response.json().catch(() => null)) as {
    error?: string;
    message?: string;
    detail?: string;
  } | null;

  return (
    payload?.error ??
    payload?.message ??
    payload?.detail ??
    `Request failed with status ${response.status}`
  );
}

export async function getAttribute(id: string): Promise<Attribute> {
  const response = await fetch(
    `${API_URL}/api/attributes/${encodeURIComponent(id)}`,
    {
      headers: {
        Accept: "application/json",
      },
    },
  );

  if (!response.ok) {
    throw new Error(await getErrorMessage(response));
  }

  return response.json() as Promise<Attribute>;
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

export async function updateAttribute(
  id: string,
  payload: UpdateAttributeDto,
): Promise<void> {
  const response = await fetch(
    `${API_URL}/api/attributes/${encodeURIComponent(id)}`,
    {
      method: "PATCH",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    },
  );

  if (!response.ok) {
    throw new Error(await getErrorMessage(response));
  }
}

export async function deleteAttribute(id: string): Promise<void> {
  const response = await fetch(
    `${API_URL}/api/attributes/${encodeURIComponent(id)}`,
    {
      method: "DELETE",
      headers: {
        Accept: "application/json",
      },
    },
  );

  if (!response.ok) {
    throw new Error(await getErrorMessage(response));
  }
}
