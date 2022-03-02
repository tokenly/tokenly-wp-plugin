import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import {
	Button,
} from '@wordpress/components';

export interface MetaFeaturedImageColumnProps {
	thumb_id: number;
	thumb_url: string;
	link: string;
}

export default function MetaFeaturedImageColumn( props: MetaFeaturedImageColumnProps ) {
	const fallbackImage: string = useInjection( TYPES.Variables.fallbackImage );

	return (
		<Button isLink href={ props.link }>
			<img loading="lazy" width={ 128 } height={ 128 } style={ { display: 'block', width: '128px', height: '128px', objectFit: 'cover' } } src={ props?.thumb_url ?? fallbackImage } />
		</Button>
	);
}
