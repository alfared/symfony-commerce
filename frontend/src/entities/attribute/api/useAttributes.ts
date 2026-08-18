import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { createAttribute, getAttributes } from "./AttributeApi";
import type { CreateAttributeDto } from "../model/attribute.dto";

export const attributeQueryKeys = {
  all: ["attributes"] as const,
};

export function useAttributes() {
  return useQuery({
    queryKey: attributeQueryKeys.all,
    queryFn: getAttributes,
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
