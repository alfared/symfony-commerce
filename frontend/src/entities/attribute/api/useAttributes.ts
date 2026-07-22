import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";

import {
  createAttribute,
  getAttribute,
  getAttributes,
  updateAttribute,
} from "./AttributeApi";

import type {
  CreateAttributeDto,
  UpdateAttributeDto,
} from "../model/attribute.dto";

export const attributeQueryKeys = {
  all: ["attributes"] as const,

  lists: () => [...attributeQueryKeys.all, "list"] as const,

  list: () => [...attributeQueryKeys.lists()] as const,

  details: () => [...attributeQueryKeys.all, "detail"] as const,

  detail: (id: string) => [...attributeQueryKeys.details(), id] as const,
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
