import * as React from 'react';

import { 
	Flex,
	Spinner,
} from '@wordpress/components';

interface PreloaderProps {
	loading: boolean;
	href?: string;
	children?: any;
}

export default function Preloader( props: PreloaderProps ) {
	return (
		<Flex justify="flex-start" align="center" style={ { minHeight: '30px' } }>
			<b>
				{ props.children }
			</b>
		{ props.loading &&
			<Spinner />
		}
		</Flex>
	);
}
