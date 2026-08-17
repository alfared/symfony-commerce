import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";

import {
  createAttribute,
  deleteAttribute,
  getAttribute,
  getAttributes,
  updateAttribute,
  createAttributeOption,
  getAttributeOptions,
  updateAttributeOption,
  deleteAttributeOption,
} from "./AttributeApi";

import type {
  CreateAttributeDto,
  UpdateAttributeDto,
  CreateAttributeOptionVariables,
  UpdateAttributeOptionVariables,
  DeleteAttributeOptionVariables,
} from "../model/attribute.dto";

export const attributeQueryKeys = {
  all: ["attributes"] as const,

  lists: () => [...attributeQueryKeys.all, "list"] as const,

  list: () => [...attributeQueryKeys.lists()] as const,

  details: () => [...attributeQueryKeys.all, "detail"] as const,

  detail: (id: string) => [...attributeQueryKeys.details(), id] as const,

  options: (attributeId: string) =>
    [...attributeQueryKeys.detail(attributeId), "options"] as const,
};

export function useAttributes() {
  return useQuery({
    queryKey: attributeQueryKeys.all,
    queryFn: getAttributes,
  });
}

export function useAttribute(id: string | undefined) {
  return useQuery({
    queryKey: attributeQueryKeys.detail(id ?? ""),
    queryFn: () => getAttribute(id as string),
    enabled: Boolean(id),
  });
}

export function useCreateAttribute() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (payload: CreateAttributeDto) => createAttribute(payload),
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: attributeQueryKeys.all,
      });
    },
  });
}

interface UpdateAttributeVariables {
  id: string;
  payload: UpdateAttributeDto;
}

export function useUpdateAttribute() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({ id, payload }: UpdateAttributeVariables) =>
      updateAttribute(id, payload),

    onSuccess: async (_, variables) => {
      await Promise.all([
        queryClient.invalidateQueries({
          queryKey: attributeQueryKeys.lists(),
        }),
        queryClient.invalidateQueries({
          queryKey: attributeQueryKeys.detail(variables.id),
        }),
      ]);
    },
  });
}

export function useDeleteAttribute() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (id: string) => deleteAttribute(id),

    onSuccess: async (_, id) => {
      queryClient.removeQueries({
        queryKey: attributeQueryKeys.detail(id),
      });

      await queryClient.invalidateQueries({
        queryKey: attributeQueryKeys.lists(),
      });
    },
  });
}

export function useAttributeOptions(attributeId: string | undefined) {
  return useQuery({
    queryKey: attributeQueryKeys.options(attributeId ?? ""),
    queryFn: () => getAttributeOptions(attributeId as string),
    enabled: Boolean(attributeId),
  });
}

export function useCreateAttributeOption() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({ attributeId, payload }: CreateAttributeOptionVariables) =>
      createAttributeOption(attributeId, payload),

    onSuccess: async (_, variables) => {
      await Promise.all([
        queryClient.invalidateQueries({
          queryKey: attributeQueryKeys.options(variables.attributeId),
        }),

        queryClient.invalidateQueries({
          queryKey: attributeQueryKeys.detail(variables.attributeId),
        }),
      ]);
    },
  });
}

export function useUpdateAttributeOption() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({
      attributeId,
      optionId,
      payload,
    }: UpdateAttributeOptionVariables) =>
      updateAttributeOption(attributeId, optionId, payload),

    onSuccess: async (_, variables) => {
      await queryClient.invalidateQueries({
        queryKey: attributeQueryKeys.options(variables.attributeId),
      });
    },
  });
}

export function useDeleteAttributeOption() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({ attributeId, optionId }: DeleteAttributeOptionVariables) =>
      deleteAttributeOption(attributeId, optionId),

    onSuccess: async (_, variables) => {
      await queryClient.invalidateQueries({
        queryKey: attributeQueryKeys.options(variables.attributeId),
      });
    },
  });
}
