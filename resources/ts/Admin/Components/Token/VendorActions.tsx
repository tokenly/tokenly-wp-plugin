import * as React from 'react';
import { Component } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
	Button,
} from '@wordpress/components';

export default function VendorActions() {
	const adminUrl = useInjection( TYPES.Variables.adminUrl );
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Flex justify="flex-start">
			<Button
				isPrimary
				isLarge
				href={ `${adminPageUrl}${namespace}-token-promise-store` }
			>
				Make a Promise
			</Button>
			<Button
				isSecondary
				isLarge
				href={ `${adminPageUrl}${namespace}-token-source-index` }
			>
				Manage Sources
			</Button>
			<Button
				isSecondary
				isLarge
				href={ `${adminPageUrl}${namespace}-token-whitelist-edit` }
			>
				Manage Whitelist
			</Button>
			<Button
				isSecondary
				isLarge
				href={ `${adminUrl}edit.php?post_type=${namespace}_token_meta` }
			>
				Manage Meta
			</Button>
		</Flex>
	);
}
