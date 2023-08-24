<?php

namespace App;

use Illuminate\Support\Facades\Http;

class Fly
{

    public function getApps(): array
    {
        $token = config('fly.token');
        $org = config('fly.org');

        // Find organization from slug
        $result = $this->client($token)
            ->post('/graphql', [
                'query' => <<<QUERY
query(\$slug: String!) {
  organization(slug: \$slug) {
    id
    name
    slug
  }
}
QUERY,
                'variables' => [
                    'slug' => $org,
                ],
            ]);

        $orgId = $result->json('data.organization.id');

        if (! $orgId) {
            // TODO: Error messaging
            return [];
        }


        // Get apps for given org
        $result = $this->client($token)
            ->post('/graphql', [
                'query' => <<<QUERY
query(\$org: ID) {
  apps(
    type: "container"
    organizationId: \$org
  ) {
    nodes {
      id
      name
      deployed
      hostname
      platformVersion
      organization {
        slug
        name
      }
      currentRelease {
        createdAt
        status
      }
      status
      machines {
        nodes {
          id
          name
          region
          state
        }
      }
      vmSize {
        name
        cpuCores
        memoryGb
      }
    }
  }
}
QUERY,
                'variables' => [
                    'org' => $orgId,
                ],
            ]);

        return ($result->successful())
            ? $result->json('data.apps.nodes')
            : [];
    }

    protected function client($token)
    {
        return Http::withToken($token)
            ->baseUrl('https://api.fly.io')
            ->throw()
            ->acceptJson()
            ->asJson();
    }
}
