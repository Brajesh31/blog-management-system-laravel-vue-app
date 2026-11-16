# ⚡ Performance and Scalability

No benchmark, load test, production traffic profile or response-time objective is included in the repository. This guide records code-based observations and a measurement plan, not performance claims.

## Current observations

### Post feed query
PostController builds a query that:
- Eager-loads the post user and tags.
- Orders by newest first.
- Applies an optional substring search across title, content and author name.
- Filters guests to published posts.
- Filters authenticated users to published posts plus their own records.
- Paginates 10 records and retains query parameters.

The query controller currently renders the missing Posts/Index page, so successful data retrieval is not the same as a complete feed experience.

### Search
The current search uses SQL LIKE matching. Leading wildcards may prevent ordinary B-tree indexes from helping. Search terms should be length-limited and query plans inspected with representative data. Consider database full-text capabilities or an external search engine only when measured needs justify it.

### Frontend assets
Vite builds the Vue and CSS assets. The build script runs vue-tsc followed by Vite. Keep dependency bundles focused and avoid loading page-specific editor code on unrelated pages if bundle size becomes material.

### Images and media
The create form limits images to 2 MB and accepts JPEG, PNG, JPG, GIF and WebP. Large user-generated media can increase storage and transfer cost. Define resizing/re-encoding, cache headers, cleanup and delivery strategy before scaling.

## Measurement plan

| Area | Measure | Suggested method |
|---|---|---|
| HTTP | p50/p95 response time, error rate | Host-level APM or request logs |
| Database | Query latency, rows examined, connections | Query logs and EXPLAIN plans |
| Feed | Time to first page, query count | Representative seeded dataset |
| Frontend | JS/CSS bundle size, LCP, INP, CLS | Vite output and browser performance tools |
| Images | Stored bytes, response size, cache hit | Storage metrics and browser network panel |
| Queue | Backlog, job duration and failures | Laravel queue monitoring if jobs are introduced |

## Recommended improvements only after measurement

1. Add indexes for observed filters/sorts and verify with EXPLAIN.
2. Keep eager loading aligned with actual page props.
3. Bound search input and consider search indexing for large content.
4. Generate responsive image variants and use safe caching headers.
5. Cache stable public content only after visibility rules are correct.
6. Add pagination limits and protect expensive routes with rate limits.
7. Establish realistic load tests and release budgets.

Do not report invented throughput, latency, Lighthouse scores or user counts.
