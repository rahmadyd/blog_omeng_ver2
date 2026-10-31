import { defineCollection, z } from 'astro:content';

const karya = defineCollection({
  type: 'content',
  schema: z.object({
    title: z.string(),
    kind: z.string().default('Design'),
    category: z.enum(['project', 'shop']).default('project'),
    role: z.string().default('Art Director & Software Engineer'),
    year: z.number().default(2024),
    summary: z.string(),
    image: z.string().default('/images/all-image-logo.png'),
    badges: z.array(z.string()).default([]),
    price: z.string().optional(),
    link: z.string().optional(),
    featured: z.boolean().default(true),
    client: z.string().optional(),
    duration: z.string().optional(),
    liveUrl: z.string().optional(),
    repoUrl: z.string().optional(),
  }),
});

export const collections = { karya };
