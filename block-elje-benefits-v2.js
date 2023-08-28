/**
 * External dependencies
 */
import PropTypes from "prop-types";
import {__} from "@wordpress/i18n";
import {Component} from "@wordpress/element";

import {InnerBlocks, InspectorControls,} from "@wordpress/block-editor";

import {Panel, PanelBody, withSpokenMessages} from "@wordpress/components";

import {BLOCK_ICON} from "./constants";

import {parseBoxValues} from "@elje/base-utils";
import SettingStyle from "@elje/editor-components/setting-style";
import SettingColor from "@elje/editor-components/setting-color";

/**
 * Component to handle edit mode of "Benefits".
 */
class BenefitsBlock extends Component {
	getInspectorControls() {
		const {
			attributes,
			setAttributes
		} = this.props;

		// @ts-ignore
		return (
			<InspectorControls key="inspector">
				<Panel className="elje-block-admin">
					<PanelBody title={__("Styling", "elje")} initialOpen={false}>
						<SettingStyle
							attributes={attributes}
							setAttributes={setAttributes}
						/>
						<SettingColor
							attributes={attributes}
							setAttributes={setAttributes}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>
		);
	}

	renderEditMode() {
		const {attributes,} = this.props;

		const cardProps = {
			className: "elje-block",
			style: {
				...parseBoxValues(attributes.paddings),
				...parseBoxValues(attributes.margins, "margin"),
			},
		};

		return (
			<div className="elje-wrapper elje-benefits-v2-wrapper">
				<div {...cardProps}>
					<InnerBlocks
						template={
							[
								[
									"core/group",
									{
										className: "benefits"
									},
									[
										[
											"core/heading",
											{
												level: 2,
												content: "Wertvolle BENEFITS auf einem Blick"
											},
											[]
										],
										[
											"core/group",
											{
												className: "benefits__row"
											},
											[
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full",
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Ihre Kunden sind Ihre Fans."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie steigern Ihren Umsatz – ohne länger arbeiten zu müssen."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Es fällt Ihnen leicht, mit neuen Kunden zu guten Abschlüssen zu kommen.\n"
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Ihre Produkte und Leistungen werden häufig weiterempfohlen.\n"
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Ihr Sales-Job macht Ihnen wieder richtig viel Spaß.\n"
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie freuen sich auf Kaltakquise und sehen es nicht als notwendiges Übel an."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie steigern Ihre Effizienz und Ihre Abschlussquoten."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie vermeiden einen Zeitverlust durch überflüssige Angebotsversendungen, die zu keinem Abschluss führen."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie unterscheiden sich angenehm anders von allen anderen."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie werden selbst zur Marke."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie verkaufen, ohne dass der Kunde es merkt."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Ihr Mindset verändert sich positiv und Sie werden kreativer."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie werden zum Macher und Gestalter."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Ihre Performance steigert sich und Sie gewinnen täglich an Sicherheit."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie entwickeln eine Strategie und gewinnen Klarheit über Ihre Erfolgsparameter."
															}
														]
													]
												],
												[
													"core/group",
													{
														className: "benefits__box_v2"
													},
													[
														[
															"core/image",
															{
																sizeSlug: "full"
															},
															[]
														],
														[
															"core/paragraph",
															{
																"content": "Sie sind in der Lage, Ihre Erfolge zu skalieren."
															}
														]
													]
												],
											]
										],
									]
								]
							]
						}
					/>
				</div>
			</div>
		);
	}

	render() {
		const {attributes,} = this.props;

		if (attributes.isPreview) {
			return BLOCK_ICON;
		}

		return (
			<>
				{this.getInspectorControls()}
				{this.renderEditMode()}
			</>
		);
	}
}

BenefitsBlock.propTypes = {
	attributes: PropTypes.object.isRequired,
	name: PropTypes.string.isRequired,
	setAttributes: PropTypes.func.isRequired,
	debouncedSpeak: PropTypes.func.isRequired,
};

export default withSpokenMessages(BenefitsBlock);
